# Wahfy - Community Support Platform

<p align="center">
  <img src="public/assets/img/logo.png" alt="Wahfy Logo" width="200">
</p>

<p align="center">
  <strong>Helping Each Other Can Make the World Better</strong>
</p>

## About Wahfy

Wahfy is a comprehensive community support platform designed to help families and individuals during times of crisis. Built with Laravel, it provides a structured way for communities to come together and support each other through organized contributions and transparent case management.

## Key Features

### 🏘️ **Community Management**
- **Group Management**: Organize members into groups with designated leaders
- **Family Management**: Create family units with family leaders
- **Individual Memberships**: Support for independent community members
- **Role-based Access**: Different permissions for leaders, members, and administrators

### 💰 **Financial Support System**
- **Incident Reporting**: Submit and verify cases requiring community support
- **Contribution Management**: Automated calculation and tracking of member contributions
- **Payment Processing**: Integrated Stripe payment processing for secure transactions
- **Receipt Generation**: Automatic receipt generation for all contributions
- **Admin Fee Management**: Configurable admin fees deducted from contributions

### 📊 **Case Management**
- **Incident Verification**: Admin verification process for submitted cases
- **Status Tracking**: Comprehensive status management for all cases and contributions
- **Document Management**: Upload and manage supporting documents and images
- **Audit Trail**: Complete audit logging for all system activities

### 💳 **Payment Features**
- **Multiple Payment Methods**: Support for card payments, mobile money, and bank transfers
- **Payment Reminders**: Automated reminder system for pending contributions
- **Transaction History**: Complete transaction tracking and reporting
- **Payment Verification**: Secure payment verification and confirmation

### 📱 **User Experience**
- **Responsive Design**: Mobile-friendly interface for all devices
- **Blog System**: Content management for community updates and news
- **Gallery**: Photo gallery for community events and activities
- **Contact System**: Integrated contact and support system
- **Notification System**: Real-time notifications for important updates

### 🔐 **Security & Compliance**
- **Secure Authentication**: Laravel's built-in authentication with email verification
- **Role-based Permissions**: Spatie Laravel Permission package for granular access control
- **Data Encryption**: Secure handling of sensitive user information
- **Audit Logging**: Comprehensive activity logging for compliance

## Technology Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Frontend**: Blade templates with responsive CSS
- **Payment Processing**: Stripe integration
- **Authentication**: Laravel UI with email verification
- **Permissions**: Spatie Laravel Permission
- **Additional Packages**: Doctrine DBAL, Laravel Tinker

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Wahfy
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run dev
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## User Types & Roles

### 👥 **User Types**
- **Group Users**: Registered by Group Leaders, can add multiple members
- **Family Users**: Registered by Family Leaders, can add family members  
- **Individual Users**: Registered independently

### 🎭 **User Roles**
- **Group/Family Leader**: Manages group/family members, updates statuses
- **Individual Member**: Manages own contributions and profile
- **Admin**: Verifies incidents, manages users, transactions, and cases

## System Workflow

1. **Registration**: Users register with one-time joining fee
2. **Probation Period**: 6-month probation period for new members
3. **Incident Submission**: Members can submit cases requiring community support
4. **Admin Verification**: Administrators verify and approve cases
5. **Contribution Collection**: System calculates and collects contributions from active members
6. **Case Closure**: Administrators can close cases when objectives are met

## Admin Features

- **Dashboard**: Comprehensive overview of system statistics
- **User Management**: Complete user lifecycle management
- **Case Management**: Verify and manage all submitted cases
- **Payment Tracking**: Monitor all transactions and contributions
- **Settings Management**: Configure system parameters and fees
- **Reporting**: Generate reports and export data
- **Audit Logs**: Track all system activities

## Contributing

We welcome contributions to improve Wahfy! Please feel free to submit issues and enhancement requests.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please contact us through the platform's contact system or create an issue in the repository.

---

**Wahfy** - Building stronger communities through technology and compassion.
